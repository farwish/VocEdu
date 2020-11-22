<?php

namespace App\Http\Controllers\VD;

use App\Http\Requests\QuestionDetail;
use App\Http\Requests\QuestionIndex;
use App\Http\Requests\QuestionNoteInfo;
use App\Http\Requests\QuestionNoteSave;
use App\Repositories\PractiseNoteRepository;
use App\Repositories\QuestionRepository;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/question/index",
     *      operationId="/api/question/index",
     *      tags={"Question v0"},
     *      summary="题目列表",
     *      description="Chapter's question list",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="pid",
     *          description="章节id",
     *          required=true,
     *          in="query",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="questionList", type="array",
     *                          @OA\Items(type="object",
     *                              @OA\Property(property="id", type="integer", description="题目id"),
     *                              @OA\Property(property="done", type="boolean", description="题是否已做, true-已做, false-未做"),
     *                          ),
     *                      ),
     *                      @OA\Property(property="openStatus", type="integer", description="用户是否开通了本题所属的科目, 1-已开通, 0-未开通"),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
     *      ),
     * )
     *
     * @param QuestionIndex $request
     * @param QuestionRepository $questionRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(QuestionIndex $request,
                          QuestionRepository $questionRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $chapterId = $validated['pid'];

        $data = $questionRepository->questionOfChapter($member, $chapterId);

        return $this->success($data);
    }

    /**
     * @OA\Get(
     *      path="/api/question/detail",
     *      operationId="/api/question/detail",
     *      tags={"Question v0"},
     *      summary="题目详情",
     *      description="Question detail",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="qid",
     *          description="题目id",
     *          required=true,
     *          in="query",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="questionDetail", type="object",
     *                          @OA\Property(property="id", type="integer", description="题目id"),
     *                          @OA\Property(property="title", type="string", description="题目标题"),
     *                          @OA\Property(property="description", type="string", description="题目描述"),
     *                          @OA\Property(property="difficulty", type="string", description="题目难度"),
     *                          @OA\Property(property="analysis", type="string", description="题目解析"),
     *                          @OA\Property(property="patternType", type="integer", description="题型分类, 0-主观题, 1-客观题"),
     *                          @OA\Property(property="patternClassify", type="integer", description="客观题选项分类, 1-单选题, 2-多选题, 4-判断题, 5-定值填空题"),
     *                          @OA\Property(property="rightAnswer", type="string", description="正确答案"),
     *                          @OA\Property(property="optionAnswer", type="object", description="答案选项",
     *                              @OA\Property(property="A", type="string"),
     *                              @OA\Property(property="B", type="string"),
     *                              @OA\Property(property="C", type="string"),
     *                          ),
     *                          @OA\Property(property="categoryId", type="integer", description="科目分类id"),
     *                          @OA\Property(property="chapterId", type="integer", description="章节id"),
     *                      ),
     *                      @OA\Property(property="openStatus", type="integer", description="用户是否开通了本题所属的科目, 1-已开通, 0-未开通"),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
     *      ),
     * )
     *
     * @param QuestionDetail $request
     * @param QuestionRepository $questionRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(QuestionDetail $request,
                           QuestionRepository $questionRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $qid = $validated['qid'];

        $question = $questionRepository->detail($member, $qid);

        return $this->success($question);
    }

    public function noteSave(QuestionNoteSave $request, PractiseNoteRepository $practiseNoteRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $qid = $validated['qid'];
        $note = $validated['note'];

        $bool = $practiseNoteRepository->saveNote($member, $qid, $note);

        return $bool ? $this->success() : $this->failure();
    }

    public function noteInfo(QuestionNoteInfo $request, PractiseNoteRepository $practiseNoteRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $qid = $validated['qid'];

        $data = $practiseNoteRepository->info($member, $qid);

        return $this->success($data);
    }
}
